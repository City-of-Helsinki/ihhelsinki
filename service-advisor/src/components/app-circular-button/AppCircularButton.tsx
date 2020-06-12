import React from 'react';

import "./AppButtonCircular.scss";
import { attachServiceClassName } from '../../helpers/render-helper';

export enum AppCircularButtonPreset {
    CLOSE = 'close',
    BACK = 'back'
}

type TOwnProps = {
    preset: AppCircularButtonPreset;
    label: string,
    clickHandler(): void
}

type TState = {
    label: string;
}

class AppCircularButton extends React.PureComponent<TOwnProps, TState> {

    constructor(props:TOwnProps) {
        super(props)
        this.state = { label: ""}
    }

    componentDidMount() {
        /* This is only done to handle if the
         * localStorage is cleared and the
         * language data is reset
         */
        this.setState({
            label: this.props.label
        });
    }

    getButtonIcon = () => {
        switch(this.props.preset) {
            case AppCircularButtonPreset.CLOSE:
                return  <i className="fi-x">&nbsp;</i>;
            case AppCircularButtonPreset.BACK:
                return  <i className="fi-play">&nbsp;</i>;
            default: return <i className="fi-x">&nbsp;</i>;
        }
    }

    render() {
        const classWithPreset = attachServiceClassName(`AppButtonCircular ${this.props.preset}`);
        const labelClassWithPreset = attachServiceClassName(`AppButtonCircular__label ${this.props.preset}`);

    return (
            <button className={classWithPreset} onClick={this.props.clickHandler}>
                <div className={labelClassWithPreset}>
                    <div className={attachServiceClassName("AppButtonCircular__label-icon")}>
                        {this.getButtonIcon() }
                    </div>
                    <div>
                        {this.state.label}
                    </div>
                </div>
            </button>
        );
    }
}

export default AppCircularButton;