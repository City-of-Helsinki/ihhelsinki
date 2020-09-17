import {action, decorate, observable} from "mobx";
import { IQuestionStore } from "../../typings/question";
import { IAnswerResult, TransformedResult } from "../../typings/answer";
import { postAnswers, fetchData } from "../../helpers/question-helper";
import { values, groupBy } from "lodash";
import { computed } from "mobx";
import { runInAction } from "mobx";
// @ts-ignore
import htmlToPdfmake from 'html-to-pdfmake';
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { TDocumentDefinitions } from "pdfmake/interfaces";
import logo from '../../assets/IHH_72_color.png';
import {convertImageToDataURL} from '../../helpers/render-helper';

pdfMake.vfs = pdfFonts.pdfMake.vfs;

class ObservableAnswerStore {
  questionStore: IQuestionStore
  answers: number[] = [];
  results: { [key: number]: IAnswerResult } = {};

  constructor(questionStore: IQuestionStore) {
      this.questionStore = questionStore;
  }

  addAnswer = (optionId: number) => {
    this.answers.push(optionId);
  };

  updateAnswers = (answers: number[]) => {
    this.answers = answers;
  }

  removeAnswer = () => {
    this.answers.pop();
  }

  reset = () => {
    this.answers= [];
  }

  fetchResult = async () => {
    try {
      const result = await postAnswers(this.answers);
      if (result) {
        runInAction(() => {
          this.results = result;
        })
      }
    } catch (err) {
      console.log(err);
    }
  }

  get transformedResults (): TransformedResult[] {
    const results = values(this.results);
    const groupedAnswers = values(groupBy(results, 'group.id'));
    return groupedAnswers
      .map(answersGroup => ({
        group: answersGroup[0].group,
        answers: answersGroup.map(result => result.answer)
      }));
  }

  getResultInPdf = async (htmlContactString: string): Promise<any> => {
    const result = this.transformedResults;

    const horizontalMargin = 40;
    const verticalMargin = 20;
    const pageWidth = 595;
    const contentWidth = pageWidth - 2 * horizontalMargin;

    let content: any = []
    result.forEach(answerGroup => {
      const groupName = answerGroup.group.name;
      const header = {
        text: groupName,
        style: 'header'
      };
      const separator = {
        canvas: [{ type: 'line', x1: 0, y1: 1, x2: contentWidth, y2: 1, lineWidth: 1}]
      };
      content = [...content, header, separator];

      answerGroup.answers.forEach(answer => {
        const formatAnswer = answer
          .replace(/\r\n\r\n/g, '<br/>');
        const text = htmlToPdfmake(`<p>${formatAnswer}</p><br/>`);
        content = [...content, ...text];
      })
    });

    // add footer to pdf file
    const dataUrl = await convertImageToDataURL(logo);

    // safe-check if contact info is missing
    let contactInfo = htmlContactString;
    if (!contactInfo) {
      const data = await fetchData();
      if (data) {
        contactInfo = data.static.contact;
      }
    }
    const contact = htmlToPdfmake(contactInfo.replace(/\n/g, '<br/>'));
    content = [...content, {
      table: {
        widths: ['50%', '50%'],
        unbreakable: true,
        body: [[
          {style: 'footer', fit: [200, 200], image: dataUrl},
          {text: contact, style: 'footer'}
        ]],
      },
      layout: {
        defaultBorder: false
      },
      unbreakable: true
    }];

    const docDefinition: TDocumentDefinitions = {
      content,
      info: {
        title: 'arrival-guide.pdf'
      },
      pageSize: 'A4',
      defaultStyle: {
        fontSize: 8
      },
      styles: {
        header: {
          fontSize: 10,
          bold: true
        },
        footer: {
          margin: [10, 10],
          fillColor: '#91c8c2',
          color: 'black',
        }
      },
      pageMargins: [horizontalMargin, verticalMargin]
    };
    const pdfmake = pdfMake.createPdf(docDefinition);
    return pdfmake;
  }
}

decorate(ObservableAnswerStore, {
  results: observable,
  answers: observable,
  transformedResults: computed,
  addAnswer: action,
  removeAnswer: action,
  reset: action,
  fetchResult: action,
  updateAnswers: action
});

export default ObservableAnswerStore;
