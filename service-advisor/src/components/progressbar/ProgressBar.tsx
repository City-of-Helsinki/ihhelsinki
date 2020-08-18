import React from 'react';
import './ProgressBar.scss';

type ProgressProps = {
  at: number;
}

const calcStyle = (props:any) => ({
  width: props.at + '%'
});

const ProgressBar = (props:ProgressProps) => (
  <div className="ProgressBar__outer">
    <div className="ProgressBar__inner" style={calcStyle(props)} />
  </div>
);

export default ProgressBar;
