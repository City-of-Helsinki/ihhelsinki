import {action, configure, decorate, observable} from "mobx";

configure({ enforceActions: "observed"});

class ObservableModalStore {

    showModal = false;

    closeModal() {
        this.showModal = false;
    }

    openModal(){
        this.showModal = true;
    }
}

decorate(ObservableModalStore, {
    showModal: observable,
    closeModal: action,
    openModal: action
});

export default ObservableModalStore;