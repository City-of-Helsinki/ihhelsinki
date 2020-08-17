import React from 'react';
import './AppButtonRounded.scss';
import { attachServiceClassName } from '../../helpers/render-helper';

type TProps = {
  clickHandler?: Function;
  data: {
    text: string
  };
  buttonType: 'action' | 'default'
} & React.ButtonHTMLAttributes<HTMLButtonElement>

const AppButtonRounded = (props: TProps) => {
  const {buttonType, data, clickHandler, ...rest} = props;

  return (
      <button
        className={attachServiceClassName("AppButtonRounded AppButtonRounded__inner "+ buttonType)}
        onClick={clickHandler ? () => clickHandler(data) : undefined}
        {...rest}
      >
          {data.text}
      </button>
    );
}

export default AppButtonRounded;
