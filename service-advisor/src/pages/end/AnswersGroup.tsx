import React from 'react';
import { TransformedResult } from '../../typings/answer';
import './EndPage.scss';
import {
  processRawHTMLString,
  convertLineBreak,
  enableNewTabTargetForLink,
  attachServiceClassName
} from '../../helpers/render-helper';

type TAnswerGroupProp = {
  result: TransformedResult
}

const AnswersGroup = (props: TAnswerGroupProp) => {
  const {result} = props;

  return (
    <div className="EndPage__info">
      <h2 className={attachServiceClassName("EndPage__subHeader")}>
        {result.group.name}
      </h2>
      {result.answers.map((answer, index) => {
        const content = processRawHTMLString(answer, [convertLineBreak, enableNewTabTargetForLink]);
        return (
          <p
            className={attachServiceClassName("EndPage__content")}
            key={index}
            dangerouslySetInnerHTML={{ __html: content }}
          />
        );
      })}
    </div>
  );
}

export default AnswersGroup;
