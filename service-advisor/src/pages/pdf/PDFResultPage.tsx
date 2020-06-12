import * as React from 'react';
import { observer, inject } from 'mobx-react';
import { IAnswerStore } from '../../typings/answer';
import { RouteComponentProps } from '@reach/router';
import './PDFResultPage.scss';
import { IStaticStore } from '../../typings/static';

type TPageProps = {
  answerStore?: IAnswerStore;
  answerIdString?: string;
  staticStore?: IStaticStore;
} & RouteComponentProps;

class PDFResultPage extends React.Component<TPageProps> {
  async componentDidMount() {
    const { answerIdString, answerStore } = this.props;
    if (answerIdString) {
      answerStore!.answers = answerIdString
        .split('-')
        .map((stringId) => parseInt(stringId, 10));
      await answerStore!.fetchResult();
      await this.loadPdf();
    }
  }

  loadPdf = async () => {
    const contact = this.props.staticStore!.contact;
    const pdf = await this.props.answerStore!.getResultInPdf(contact);
    pdf.getDataUrl((url: string) => {
      const iframe: any = document.getElementById('PdfPage__arrivalGuide');
      iframe.src = url;
    }); 
  }

  render() {
    return (
      <iframe
        id="PdfPage__arrivalGuide"
        title="Arrive guide"
        className="PdfPage__iframe"
        frameBorder='0'
      />
    );
  };
}

export default inject('answerStore', 'staticStore')(observer(PDFResultPage));
