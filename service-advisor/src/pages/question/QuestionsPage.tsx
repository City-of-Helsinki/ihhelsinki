import React from 'react';
import { observer, inject } from 'mobx-react';
import { navigate, RouteComponentProps} from '@reach/router';
import ProgressBar from '../../components/progressbar/ProgressBar';
import AppButtonCircular, { AppCircularButtonPreset } from '../../components/app-circular-button/AppCircularButton';
import Question from "../../components/question/Question";
import AppCloseDialog from "../../components/app-close-dialog/AppCloseDialog";
import { IQuestionStore, IQuestionOption } from '../../typings/question';
import { IAnswerStore } from '../../typings/answer';
import { IModalStore } from '../../typings/modal';

import './QuestionsPage.scss';
import { ILanguageStore } from '../../typings/language';
import { attachServiceClassName } from '../../helpers/render-helper';

type TOwnProps = {
  questionStore?: IQuestionStore,
  answerStore?:IAnswerStore,
  modalStore?: IModalStore,
  languageStore?: ILanguageStore
}

type TComponentProps = TOwnProps & RouteComponentProps;

class QuestionsPage extends React.Component<TComponentProps> {
  closeApp = () => {
    this.props.modalStore!.openModal();
  };

  goBackQuestion = () => {
    const {answerStore, questionStore} = this.props;
    questionStore!.goBackQuestion();
    answerStore!.removeAnswer();
  }

  onQuestionClickHandler = (option: IQuestionOption)  => {
    const {answerStore, questionStore} = this.props;
    // save answer and go to next question
    answerStore!.addAnswer(option.id);
    questionStore!.nextQuestion(answerStore!.answers);

    if (questionStore!.isLast) {
      navigate('/questions/end');
    }
  };

  render() {
    const {questionStore, languageStore} = this.props;
    const question = questionStore!.currentQuestion;
    const index = questionStore!.currentIndex;

    return (
      <>
        <div tabIndex={0} aria-live="polite" className={attachServiceClassName("QuestionPage")}>
          <ProgressBar at={questionStore!.progress}/>
          <Question clickHandler={this.onQuestionClickHandler} question={question}/>
          <div className={"Action_buttons__container"}>
            {index > 0
                ? <AppButtonCircular
                    label={languageStore!.getTranslatedText('back')}
                    preset={AppCircularButtonPreset.BACK}
                    clickHandler={this.goBackQuestion} />
                : null
            }
            <AppButtonCircular
                label={languageStore!.getTranslatedText('close')}
                preset={AppCircularButtonPreset.CLOSE}
                clickHandler={this.closeApp}
            />
          </div>
        </div>
        <AppCloseDialog />
      </>
    )
  }
}

export default inject('questionStore','answerStore', 'modalStore', 'languageStore')(observer(QuestionsPage));
