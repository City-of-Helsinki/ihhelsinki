import {observable, action, decorate} from 'mobx';
import { IStaticContent } from '../../typings/static';

class ObservableStaticStore {
  instructions: string = '';
  contact: string = '';
  disclaimer: string = '';
  logos: string[] = [];
  showDisclaimer: boolean = false;
  
  setStaticContent = (content: IStaticContent) => {
    this.instructions = content.instructions || '';
    this.contact = content.contact || '';
    this.disclaimer = content.disclaimer || '';
    this.logos = [
      ...content.logos.filter(url => url)
    ];
  }

  toggleDisclaimer = () => {
    this.showDisclaimer = !this.showDisclaimer;
  }
}

decorate(ObservableStaticStore, {
  instructions: observable,
  contact: observable,
  disclaimer: observable,
  showDisclaimer: observable,
  logos: observable,
  setStaticContent: action,
  toggleDisclaimer: action
})

export default ObservableStaticStore;
