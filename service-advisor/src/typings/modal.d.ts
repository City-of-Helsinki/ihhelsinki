export interface IModalStore {
    showModal: boolean;
    closeModal(): void;
    openModal(): void;
}