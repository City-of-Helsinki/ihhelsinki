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
                return  <i className="fi-x" />;
            case AppCircularButtonPreset.BACK:
                return  <i className="fi-play" />;
            default: return <i className="fi-x" />;
        }
    }

    render() {
        const classWithPreset = attachServiceClassName(`AppButtonCircular ${this.props.preset}`);
        const labelClassWithPreset = attachServiceClassName(`AppButtonCircular__label ${this.props.preset}`);

    return (
            <div className={classWithPreset} onClick={this.props.clickHandler}>
                <div className={labelClassWithPreset}>
                    <div className={attachServiceClassName("AppButtonCircular__label-icon")}>
                        {this.getButtonIcon() }
                    </div>
                    <button>
                        {this.state.label}
                    </button>
                </div>
            </div>
        );
    }
}

export default AppCircularButton;
