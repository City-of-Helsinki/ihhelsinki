export interface IAnswerStore {
  results: { [key: number]: IAnswerResult };
  answers: number[];
  transformedResults: TransformedResult[];
  getResultInPdf: (contact: string) => Promise<any>;
  addAnswer: (optionId: number) => void;
  removeAnswer: () => void;
  reset(): void;
  fetchResult: () => void;
}

export interface IAnswerResult {
  group: {
    id: number;
    name: string;
  };
  answer: string;
  weight: number;
}

export type TransformedResult = {
  group: {
    id: number;
    name: string;
  };
  answers: string[];
}
