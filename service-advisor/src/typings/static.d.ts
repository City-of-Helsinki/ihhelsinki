import { IStaticContent } from './static.d';

export interface IStaticContent {
  instructions: string;
  contact: string;
  disclaimer: string;
  logos: string[];  
}

export interface IStaticStore {
  instructions: string;
  contact: string;
  disclaimer: string;
  logos: string[];
  showDisclaimer: boolean;
  setStaticContent: (content: IStaticContent) => void;
  toggleDisclaimer: () => void;
}
