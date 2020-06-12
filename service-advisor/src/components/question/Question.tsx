import React from 'react';
import './Question.scss';
import {IQuestion, IQuestionOption} from "../../typings/question";
import AppButtonRounded from "../app-button-rounded/AppButtonRounded";
import { inactivityReset } from '../../helpers/question-helper';
import { attachServiceClassName } from '../../helpers/render-helper';

export interface IStateQuestionProps {
  question: IQuestion,
  clickHandler: (option: IQuestionOption) => void
}

const getQuestionOptionElements =((props: IStateQuestionProps) => {
  return props.question.options.map((option:IQuestionOption) => (
    <div key={option.id} className="Question__option">
      <AppButtonRounded
        data={{...option, text: option.value}}
        clickHandler={props.clickHandler}
        buttonType={option.value==="NO" ? "action": "default"}/>
    </div>
  ))
});

const getQuestionDescriptionElements = (q: IQuestion) => {
  return q.body !== ''
    ? (
      <div
        className={attachServiceClassName("Question__description")}
        dangerouslySetInnerHTML={{__html: q.body}}
      />
    ) : null;
}

const Question = (props: IStateQuestionProps) => (
    <div className={attachServiceClassName("Question")}>
      <div className={attachServiceClassName("Question__text")}> { props.question.title}</div>
      <div className={attachServiceClassName("Question__descriptions")}>
        {getQuestionDescriptionElements(props.question)}
      </div>
      <br/>
      <div className="Question_options">
          {getQuestionOptionElements(props)}
      </div>
    </div>
  );

  inactivityReset();

export default Question;