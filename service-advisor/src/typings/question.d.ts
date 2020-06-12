import { IQuestion } from './question.d';

export interface IQuestionStore {
  questions: IQuestion[];
  queue: number[];
  progress: number;
  setQuestions: (questions: IQuestion[]) => void;
  nextQuestion: (answers: number[]) => void;
  currentQuestion: IQuestion;
  currentIndex: number;
  isLast: boolean;
  goBackQuestion: () => void;
  reset: () => void;
}

interface IQuestionOption {
  id: number;
  value: string;
}

interface IQuestion {
  title: string;
  body: string;
  options: QuestionOption[];
  hide_when: number[];
}
