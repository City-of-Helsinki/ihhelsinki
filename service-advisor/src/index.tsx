import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './global-styles/global.scss';
import { Provider } from "mobx-react";
import ObservableModalStore from "./config/observables/ObservableModalStore";
import ObservableQuestionStore from "./config/observables/ObservableQuestionStore";
import ObservableAnswerStore from "./config/observables/ObservableAnswerStore";
import ObservableLanguageStore from './config/observables/ObservableLanguageStore';
import ObservableStaticStore from './config/observables/ObservableStaticStore';

const modalStore = new ObservableModalStore();
const questionStore = new ObservableQuestionStore();
const answerStore = new ObservableAnswerStore(questionStore);
const languageStore = new ObservableLanguageStore();
const staticStore = new ObservableStaticStore();

ReactDOM.render(
    <Provider
      modalStore={modalStore}
      questionStore={questionStore}
      answerStore={answerStore}
      languageStore={languageStore}
      staticStore={staticStore}>
        <App />
    </Provider>,
  document.getElementById('root')
);
