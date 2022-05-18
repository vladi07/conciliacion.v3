import {Controller} from 'CasoConciliatorio.php';
import {Modal} from 'bootstrap.php';
import $ from 'jquery';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];
    static values = {
        formUrl: String,
    }

    async openModal(event) {
        this.modalBodyTarget.innerHTML = 'Cargando...';
        //console.log(this.formUrlValue);
        const modal = new Modal(this.modalTarget);
        modal.show();

        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue);
    }
}