import React, {Component} from 'react';


type TState = { hasError: boolean }

class ErrorBoundary extends Component<any, TState> {

    constructor(props:any) {
        super(props);
        this.state =  { hasError: false }
    }

    componentDidCatch(error: Error, errorInfo: React.ErrorInfo): void {
        this.setState({ hasError: true });
    }

    render() {
        if (this.state.hasError) {
            return  <div><h2>Oops, something went wrong!</h2></div>
        }
        return this.props.children
    }
}

export default ErrorBoundary;