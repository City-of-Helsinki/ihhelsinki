import React from 'react';
import { observer, inject } from 'mobx-react';
import {navigate, RouteComponentProps} from "@reach/router";
import LogoHeader from '../../components/logo-header/LogoHeader';
import AppButtonRounded from '../../components/app-button-rounded/AppButtonRounded';
import './Startpage.scss';
import { ILanguageStore } from '../../typings/language';
import { IStaticStore } from '../../typings/static';
import { processRawHTMLString, convertLineBreak, attachServiceClassName } from '../../helpers/render-helper';
import { IModalStore } from '../../typings/modal';
import { IQuestionStore } from '../../typings/question';
import { IAnswerStore } from '../../typings/answer';

type TOwnProps = {
  languageStore?: ILanguageStore;
  staticStore?: IStaticStore;
  modalStore?: IModalStore;
  questionStore?: IQuestionStore;
  answerStore?: IAnswerStore;
}

type PageProps = TOwnProps & RouteComponentProps;

class StartPage extends React.Component<PageProps> {
  componentDidMount() {
    this.props.languageStore!.reset();
    this.props.modalStore!.closeModal();
    this.props.questionStore!.reset();
    this.props.answerStore!.reset();
  }

  render() { 
    const {languageStore, staticStore} = this.props;

    const onStartButtonHandler = () => {
      navigate('/questions');
    };

    return (
      <div className="StartPage">
        <LogoHeader/>
        <div
          className={attachServiceClassName('StartPage__meta')}
          dangerouslySetInnerHTML={{__html: processRawHTMLString(staticStore!.instructions, [convertLineBreak])}}
        />
        <div className="StartPage__buttonGroup">
          <AppButtonRounded
            buttonType={"default"}
            data={{text: languageStore!.getTranslatedText('startButtonText')}}
            clickHandler={onStartButtonHandler}
          />
          <button
            className={attachServiceClassName("StartPage_disclaimer")}
            onClick={staticStore!.toggleDisclaimer}
          >
            {languageStore!.getTranslatedText('disclaimer')}
          </button>
        </div>
      </div>
    );
  }
}

export default inject('questionStore','answerStore','modalStore', 'languageStore', 'staticStore')(observer(StartPage));
