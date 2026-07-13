Alpine.data("mediaBrowser", ({ statePath, multiple }) => ({
    selectedFiles: [],
    multiple,

    isSelected(id) {
        return this.selectedFiles.some((media) => media.id === id);
    },

    toggleFile(id, url, mimeType) {
        if (this.multiple) {
            this.selectedFiles = this.isSelected(id)
                ? this.selectedFiles.filter((media) => media.id !== id)
                : [...this.selectedFiles, { id, url, mime_type: mimeType }];
        } else {
            this.selectedFiles = this.isSelected(id)
                ? []
                : [{ id, url, mime_type: mimeType }];
        }
    },

    hasSelection() {
        return this.selectedFiles.length > 0;
    },

    confirm() {
        const value = this.multiple
            ? this.selectedFiles
            : this.selectedFiles[0];

        this.$dispatch("file-selected", { value, statePath });
    },

    resetSelection() {
        this.selectedFiles = [];
    },
}));
