import React from 'react'
import './AppInput.scss'

type AppInputProps = {
  errorMessage?: string,
  inputProps: React.InputHTMLAttributes<HTMLInputElement>
}

const AppInput: React.SFC<AppInputProps> = (props: AppInputProps) => {
  const {errorMessage, inputProps} = props;

  return (
    <div className="AppInput">
      <input {...inputProps} />
      {errorMessage && (
        <span>{errorMessage}</span>
      )}
    </div>
  );
};

export default AppInput
