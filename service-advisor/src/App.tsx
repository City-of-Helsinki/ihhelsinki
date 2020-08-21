import React from 'react';
import { observer } from 'mobx-react/custom';
import { inject } from 'mobx-react';
import AppRouter from "./routing/AppRouter";
import './App.scss';
import {fetchData} from './helpers/question-helper';
import { IQuestionStore } from './typings/question';
import { IStaticStore } from './typings/static';
import { processRawHTMLString, convertLineBreak, attachServiceClassName } from './helpers/render-helper';
import { ILanguageStore } from './typings/language';
import Footer from './components/footer/Footer';

type TComponentProps = {
  questionStore?: IQuestionStore,
  staticStore?: IStaticStore,
  languageStore?: ILanguageStore
}

class App extends React.Component<TComponentProps> {
  async componentDidMount() {
    const data = await fetchData();
    if (data) {
      this.props.questionStore!.setQuestions(data.questions);
      this.props.staticStore!.setStaticContent(data.static);
    }
  }

  render() {
    const {staticStore, languageStore} = this.props;
    const disclaimer = processRawHTMLString(staticStore!.disclaimer, [convertLineBreak]);

    return (
      <div className="App">
        <div className="App__page-wrapper">
          <AppRouter/>
        </div>

        {/* popup card for legal disclaimer */}
        {staticStore!.showDisclaimer && (
          <main className="App__disclaimer-popup">
            <div className="App-overlay">
              <div className={attachServiceClassName("App__disclaimer-container")}>
                <div className={attachServiceClassName("App__disclaimer-header")}>
                  <span>{languageStore!.getTranslatedText('disclaimer')}</span>
                  <button
                      onClick={staticStore!.toggleDisclaimer}
                      aria-label={languageStore!.getTranslatedText('close')}
                  >
                    <i className="fi-x"/>
                  </button>
                </div>
                <div className="App__disclaimer-divider" />
                <div
                  className={attachServiceClassName("App__disclaimer")}
                  dangerouslySetInnerHTML={{__html: disclaimer}}
                />
              </div>
            </div>
          </main>
        )}

        {process.env.REACT_APP_VERSION === 'public' && (
          <Footer logos={staticStore!.logos} contact={staticStore!.contact} />
        )}
      </div>
    );
  }
}

export default inject('questionStore', 'staticStore', 'languageStore')(observer(App));
