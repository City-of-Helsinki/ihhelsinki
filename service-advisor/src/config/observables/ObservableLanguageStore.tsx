import {observable, decorate, action} from 'mobx';
import {Language} from '../../typings/language.d';
import translations from '../../translations';

class ObservableLanguageStore {
    selectedLanguage: Language = Language.ENGLISH;

    setLanguage = (lang: Language = Language.ENGLISH) => {
        this.selectedLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);
    }

    getLanguage = (): Language => {
      const language = localStorage.getItem('selectedLanguage');
      if (!language) {
        // set to english by default
        this.setLanguage();
      } else {
        if (language !== this.selectedLanguage) {
          this.selectedLanguage = language as Language;
        }
      }
      return this.selectedLanguage;
    }

    getTranslatedText = (id: string): string => {
      const lang = this.getLanguage();
      return (translations[lang] as any)[id];
    }

    reset = () => {
      // reset to default language
      this.selectedLanguage = Language.ENGLISH;
      localStorage.removeItem('selectedLanguage');
    }
}

decorate(ObservableLanguageStore, {
    selectedLanguage: observable,
    setLanguage: action,
    reset: action
});

export default ObservableLanguageStore;
