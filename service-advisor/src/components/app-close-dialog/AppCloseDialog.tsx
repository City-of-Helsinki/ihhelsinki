import React from 'react';
import AppButtonRounded from "../app-button-rounded/AppButtonRounded";
import {inject} from "mobx-react/custom";
import {observer} from "mobx-react";
import {navigate} from "@reach/router";
import { IQuestionStore } from '../../typings/question';
import { IAnswerStore } from '../../typings/answer';
import { IModalStore } from '../../typings/modal';

import './AppCloseDialog.scss';
import { ILanguageStore } from '../../typings/language';
import { attachServiceClassName } from '../../helpers/render-helper';

type TDialogProps = {
  questionStore?: IQuestionStore,
  modalStore?: IModalStore,
  answerStore?: IAnswerStore,
  languageStore?: ILanguageStore
}

class AppCloseDialog extends React.Component<TDialogProps> {
  private popUp = React.createRef<HTMLDivElement>();

  componentDidUpdate() {
    if ( this.popUp.current !== null) {
      this.popUp.current.focus();
    }
  }

  render() {
    const {languageStore} = this.props;

    const closeApp = async () => {
      await navigate('/');
    };

    const continueWithApp = () => {
      this.props.modalStore!.closeModal();
    };

    const getVisibility = () =>
        this.props.modalStore!.showModal
            ? "visible"
            : "hidden";

    return (
        <>
          <div className={"AppDialogWrapperBackground "+getVisibility()} />
          <div className={"AppDialogWrapper "+getVisibility()}>
            <div className={attachServiceClassName("AppDialog")} tabIndex={0} ref={this.popUp}>
              <div className={attachServiceClassName("AppDialog__heading")}>
                {languageStore!.getTranslatedText('closeApp')}
              </div>
              <p className={attachServiceClassName("AppDialog__info")}>
                {languageStore!.getTranslatedText('closeAppWarn')}
              </p>
              <div className="AppDialog__controls">
                <AppButtonRounded
                    buttonType="default"
                    data={{text: languageStore!.getTranslatedText('continue')}}
                    clickHandler={continueWithApp} />
                <AppButtonRounded
                    buttonType="action"
                    data={{text: languageStore!.getTranslatedText('close')}}
                    clickHandler={closeApp} />
              </div>
            </div>
          </div>
        </>
    );
  }
}

export default inject('questionStore','modalStore','answerStore', 'languageStore')(observer(AppCloseDialog));
