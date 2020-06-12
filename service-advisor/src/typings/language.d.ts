export enum Language {
    ENGLISH = 'en',
    FINNISH = 'fi',
    SWEDISH = 'se',
    RUSSIAN = 'ru'
}

export interface ILanguageStore {
    selectedLanguage: Language;
    setLanguage(lang: Language): void;
    getLanguage(): Language;
    getTranslatedText(id: string): string;
    reset: () => void;
}

export enum StorageKey {
    SELECTED_LANGUAGE = 'selectedLanguage'
}