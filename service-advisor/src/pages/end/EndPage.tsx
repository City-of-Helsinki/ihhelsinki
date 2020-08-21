import React from 'react';
import {RouteComponentProps, navigate} from "@reach/router";
import { observer, inject } from 'mobx-react';
import ProgressBar from "../../components/progressbar/ProgressBar"
import AppButtonRounded from "../../components/app-button-rounded/AppButtonRounded";
import { IAnswerStore } from '../../typings/answer';
import './EndPage.scss';
import { ILanguageStore } from '../../typings/language';
import { IQuestionStore } from '../../typings/question';
import { FadeLoader } from 'react-spinners';
import {
  attachServiceClassName
} from '../../helpers/render-helper';
import { sendResultAsEmail } from '../../helpers/question-helper'
import AppInput from '../../components/app-input/AppInput';
import { IStaticStore } from '../../typings/static';
import LogoHeader from '../../components/logo-header/LogoHeader';
import AnswersGroup from './AnswersGroup';

type TPageProps = {
  answerStore?: IAnswerStore;
  languageStore?: ILanguageStore;
  questionStore?: IQuestionStore;
  staticStore?: IStaticStore;
} & RouteComponentProps

type TPageState = {
  email: string,
  emailSent?: boolean
}

class EndPage extends React.Component<TPageProps, TPageState> {
  state = {
    email: "",
    emailSent: undefined
  }

  async componentDidMount() {
    await this.props.answerStore!.fetchResult();
  }

  onChangeEmail = (e: React.ChangeEvent<HTMLInputElement>) => {
    this.setState({
      email: e.target.value
    });
  }

  startAgain = () => {
    this.props.questionStore!.reset();
    this.props.answerStore!.reset();
    navigate('/');
  }

  savePdf = async () => {
    const contact = this.props.staticStore!.contact;
    const pdf = await this.props.answerStore!.getResultInPdf(contact)
    pdf.download('arrive-guide.pdf');
  }

  viewPdf = () => {
    const answers = this.props.answerStore!.answers;
    navigate(`/result/${answers.join('-')}`);
    // window.open(`/result/${answers.join('-')}`);
  }

  sendAsEmail = (event: React.FormEvent<HTMLFormElement>) => {
    const answers = this.props.answerStore!.answers;
    // can't use async/await for form onSubmit yet
    sendResultAsEmail(this.state.email, answers)
      .then(status => {
        this.setState({
          emailSent: Boolean(status)
        });
      });
    event.preventDefault();
  }

  printToReceipt = () => {
    window.print();
  }

  render() {
    const {languageStore, answerStore} = this.props;
    const {email, emailSent} = this.state;
    const results = answerStore!.transformedResults;

    return (
      <>
        <ProgressBar at={100} />
        <div className={attachServiceClassName("EndPage")}>
          <div className="EndPage__logo">
            <LogoHeader />
          </div>

          {process.env.REACT_APP_VERSION === 'service' && (
            <>
              <div className="EndPage__header">
                <h1 className={attachServiceClassName("EndPage__title")}>
                  {languageStore!.getTranslatedText('header')}
                </h1>
                <p className={attachServiceClassName("EndPage__notice")}>
                  {languageStore!.getTranslatedText('finalWords')}
                </p>
              </div>
              <div className={attachServiceClassName("EndPage__controls")}>
                <AppButtonRounded
                  buttonType='default'
                  data={{ text: languageStore!.getTranslatedText('print') }}
                  onClick={this.printToReceipt}
                  type='submit'
                />
                <AppButtonRounded
                  buttonType='default'
                  data={{ text: languageStore!.getTranslatedText('close') }}
                  onClick={this.startAgain}
                  type='submit'
                />
              </div>
            </>
          )}

          {results.length > 0 || answerStore!.answers.length === 0
            ? results.map(result => (
              <AnswersGroup result={result} key={result.group.id} />
            ))
            : <FadeLoader loading radius={50} />
          }

          {process.env.REACT_APP_VERSION === 'public' && (
            <>
              <div>
                <AppButtonRounded
                  buttonType='default'
                  data={{ text: languageStore!.getTranslatedText('viewPdf') }}
                  clickHandler={this.viewPdf}
                />
                <AppButtonRounded
                  buttonType='default'
                  data={{ text: languageStore!.getTranslatedText('downloadPdf') }}
                  title={languageStore!.getTranslatedText('downloadPdf')}
                  clickHandler={this.savePdf}
                />
              </div>

              <form className="EndPage__email" onSubmit={this.sendAsEmail}>
                <h2>{languageStore!.getTranslatedText('sendAsEmail')}</h2>
                <div>
                  <label htmlFor="email" className="visually-hidden">Email</label>
                  <AppInput
                    errorMessage={languageStore!.getTranslatedText('invalidEmail')}
                    inputProps={{
                      id: 'email',
                      type: 'email',
                      value: email,
                      onChange: this.onChangeEmail
                    }}
                  />
                  <AppButtonRounded
                    type='submit'
                    buttonType='default'
                    data={{ text: languageStore!.getTranslatedText('send') }}
                  />
                </div>
                {/* alert message here */}
                {typeof emailSent === 'boolean' && (
                  <span className={emailSent ? "Endpage__emailSuccess" : "Endpage__emailError"}>
                    {languageStore!.getTranslatedText(emailSent ? 'emailSent' : 'emailSendFailed')}
                  </span>
                )}
              </form>
            </>
          )}

          {process.env.REACT_APP_VERSION === 'public' && (
            <div className="EndPage__controls">
              <AppButtonRounded
                buttonType='default'
                data={{ text: languageStore!.getTranslatedText('startAgain') }}
                onClick={this.startAgain}
                type='submit'
              />
            </div>
          )}
        </div>
      </>
    );
  }
}

export default inject('answerStore', 'languageStore', 'questionStore', 'staticStore')(observer(EndPage));
