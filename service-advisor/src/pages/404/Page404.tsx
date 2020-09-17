import React from 'react';
import {inject, observer} from 'mobx-react';
import { RouteComponentProps} from "@reach/router";
import LogoHeader from '../../components/logo-header/LogoHeader';
import './Page404.scss';
import { ILanguageStore } from '../../typings/language';

type TComponentProps = {
  default: boolean;
  languageStore?: ILanguageStore;
}

const Page404 = (props:RouteComponentProps<TComponentProps>) => {
  return (
    <div className="Page404">
      <LogoHeader />
      <div className="Page404__label">404</div>
      <div className="Page404__content">
        <p>{props.languageStore!.getTranslatedText('t404')}</p>
      </div>
      <div className="Page404__controls">
        <a href="/">
          <i className="fi-home"/>
          {props.languageStore!.getTranslatedText('goHome')}
        </a>
      </div>
    </div>
  );
}

export default inject('languageStore')(observer(Page404));
