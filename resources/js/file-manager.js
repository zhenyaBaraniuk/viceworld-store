import Panzoom from '@panzoom/panzoom'

/* global Alpine */
Alpine.data('fileManager', () => ({
    showModal: false,
    selectedFile: null,
    clickTimer: null,

    openFile(file) {
        this.selectedFile = file;
        this.showModal = true;

        this.$nextTick(() => {
           const el = document.getElementById('preview-image');
           const img = el.querySelector('img');

           const init = () => {
               this.panzoom = Panzoom(el, { maxScale: 3 , minScale: 0.5 });
               el.parentElement.addEventListener('wheel', this.panzoom.zoomWithWheel)
           };

            img.complete ? init() : img.addEventListener('load', init, { once: true });
        });
    },

    selectFolder(id) {
        clearTimeout(this.clickTimer);
        this.clickTimer = setTimeout(() => {
            this.$wire.selectFolder(id);
        }, 250);
    },

    navigateToFolder(id) {
        clearTimeout(this.clickTimer);

        this.$wire.navigateToFolder(id);
    },

    closeModal() {
        this.showModal = false;
        this.panzoom?.destroy();
        this.panzoom = null;
    },
}))
