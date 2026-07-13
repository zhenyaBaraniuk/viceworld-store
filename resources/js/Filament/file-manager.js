Alpine.data("fileManager", () => ({
    showModal: false,
    selectedFile: null,
    clickTimer: null,

    openFile(file) {
        this.selectedFile = file;
        this.showModal = true;
    },

    openViewer() {
        const viewer = new Viewer(this.$refs.previewImg, {
            navbar: false,
            title: false,
            toolbar: { zoomIn: 1, zoomOut: 1, reset: 1 },
        });

        viewer.show();

        this.$refs.previewImg.addEventListener(
            "hidden.viewer",
            () => viewer.destroy(),
            { once: true },
        );
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
    },
}));
