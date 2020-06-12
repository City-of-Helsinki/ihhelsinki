import React from 'react';
import  logo from '../../assets/IHH_72_color.png';
import './LogoHeader.scss';
import {attachServiceClassName} from '../../helpers/render-helper';

const LogoHeader = () => (
  <div className={attachServiceClassName('App-logoContainer')}>
    <img src={logo} className="App-logo" alt="logo" />
  </div>
);

export default LogoHeader