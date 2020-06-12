import {computed, action, observable, decorate} from 'mobx';
import {IQuestion} from "../../typings/question.d";
import {intersection} from 'lodash';

const defaultQuestion: IQuestion = {
  title: '',
  body: '',
  options: [],
  hide_when: []
}; 

const DEFAULT_MAX_QUESTIONS = 22;

class ObservableQuestionStore {
  questions: IQuestion[] = [];
  queue: number[] = [0];

  nextQuestion = (answers: number[]) => {
    let nextQuestionIndex = this.currentIndex + 1;

    // skip the questions depending on answered questions
    while (nextQuestionIndex < this.questions.length) {
      if (intersection(answers, this.questions[nextQuestionIndex].hide_when).length === 0) {
        break;
      }
      nextQuestionIndex++;
    }

    // add -1 index to queue to mark last question (can't find next question)
    if (nextQuestionIndex > this.questions.length - 1) {
      nextQuestionIndex = -1;
    }

    this.queue.push(nextQuestionIndex);
  }

  goBackQuestion = () => {
    this.queue.pop();
  }

  setQuestions = (questions: IQuestion[]) => {
    this.questions = questions;
  }

  reset = () => {
    this.queue = [0];
  }

  get currentQuestion(): IQuestion {
    if (this.queue.length <= 0) {
      return defaultQuestion;
    }
    const index = this.queue[this.queue.length - 1];
    return this.questions[index] || defaultQuestion;
  }

  get currentIndex(): number {
    return this.queue[this.queue.length - 1];
  }

  get isLast(): boolean {
    return this.currentIndex < 0; 
  }

  get progress(): number {
    const questionsCount = this.questions.length > 0
      ? this.questions.length
      : DEFAULT_MAX_QUESTIONS;
    return (this.queue.length - 1) / questionsCount * 100;
  }
}

decorate(ObservableQuestionStore, {
  questions: observable,
  queue: observable,
  setQuestions: action,
  currentQuestion: computed,
  currentIndex: computed,
  isLast: computed,
  goBackQuestion: action,
  nextQuestion: action,
  reset: action
});

export default ObservableQuestionStore;