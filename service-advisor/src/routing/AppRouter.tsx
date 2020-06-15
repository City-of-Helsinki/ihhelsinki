import React from 'react';
import { Router } from "@reach/router";
import { StartPage, QuestionsPage, EndPage, Page404, PDFResultPage } from '../pages/';

const AppRouter = () => (
        <Router>
          {/* homepage is currently omitted because the app is only in english atm,
          change redirection to homepage if it is in used */}
          {/* <Redirect noThrow from="/" to="start" /> */}
          {/* <HomePage path="home"/> */}
          <StartPage path="/"/>
          <QuestionsPage path="questions/"/>
          <EndPage path="questions/end"/>
          <PDFResultPage path="result/:answerIdString" />
          <Page404 default />
        </Router>
);

export default AppRouter;
