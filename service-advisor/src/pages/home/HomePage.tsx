import React from 'react';
import { RouteComponentProps } from '@reach/router';
import { navigate } from "@reach/router"
import LogoHeader from '../../components/logo-header/LogoHeader';
import AppButtonRounded from '../../components/app-button-rounded/AppButtonRounded';
import {Language, ILanguageStore} from "../../typings/language.d";
import {inject, observer} from "mobx-react";
import './Homepage.scss'
import translations from '../../translations';

type TPageProps = {
  languageStore?: ILanguageStore
}

type PageProps = TPageProps & RouteComponentProps;

class HomePage extends React.Component<PageProps> {
  getOnGroupButtonClicked = (language: Language) => () => {
    this.props.languageStore!.setLanguage(language);
    navigate('/start');
  };

  render() {
    return (
      <div className="HomePage">
        <LogoHeader />
        <div className="HomePage__button-group">
          <AppButtonRounded
            buttonType="default"
            clickHandler={this.getOnGroupButtonClicked(Language.ENGLISH)}
            data={{text: translations.en.welcome}} />
          {/* hide other language options since currently only english is supported */}
          {/* <AppButtonRounded
            buttonType="default"
            clickHandler={this.getOnGroupButtonClicked(Language.FINNISH)}
            data={{text: translations.fi.welcome}} />
          <AppButtonRounded
            buttonType="default"
            clickHandler={this.getOnGroupButtonClicked(Language.RUSSIAN)}
            data={{text: translations.ru.welcome}} />
          <AppButtonRounded
            buttonType="default"
            clickHandler={this.getOnGroupButtonClicked(Language.SWEDISH)}
            data={{text: translations.se.welcome}} /> */}
        </div>
      </div>
    );
  }
}

export default inject('languageStore')(observer(HomePage));