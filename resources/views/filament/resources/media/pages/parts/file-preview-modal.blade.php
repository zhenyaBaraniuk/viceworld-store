<div x-show="showModal" x-cloak>
    <div class="fixed inset-0 bg-fm-on-surface/40 flex items-center justify-center pt-24 p-6 z-25">
        <div
            class="bg-fm-surface-white rounded-xl shadow-[0_20px_60px_rgba(11,28,48,0.15)] w-full  max-w-4xl h-[700px] max-h-[921px] flex flex-col overflow-hidden">
            <div class="px-6 h-16 flex items-center justify-between border-b border-fm-surface-container">
                <div class="fm-row">
                    <span class="material-symbols-outlined text-fm-primary">visibility</span>
                    <h3 class="text-lg font-bold tracking-tight text-fm-on-surface">Asset Preview</h3>
                </div>

                <button
                    type="button"
                    @click="closeModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-fm-surface-low transition-colors duration-200">
                    <span class="material-symbols-outlined text-fm-on-surface-variant">close</span>
                </button>
            </div>

            <div class="flex flex-1 min-h-0">
                <div class="flex-3 bg-fm-surface-low flex items-center justify-center overflow-hidden">
                    <template x-if="selectedFile?.mime_type?.startsWith('image/')">
                        <div id="preview-image" class="relative group h-full w-full flex items-center justify-center">
                            <img
                                x-ref="previewImg"
                                class="max-w-full max-h-full rounded-xl shadow-lg object-contain cursor-pointer"
                                :src="selectedFile?.url"
                                :alt="selectedFile?.name"
                                @click="openViewer()"
                            />
                        </div>
                    </template>

                    <template x-if="selectedFile?.mime_type?.startsWith('video/')">
                        <video
                            controls
                            class="w-full h-full rounded-xl object-contain"
                        >
                            <source :src="selectedFile?.url">
                        </video>
                    </template>
                </div>

                <div class="flex-2 border-l border-fm-surface-container p-8 flex flex-col gap-8 overflow-y-auto">

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-fm-on-surface-variant">File
                            Name</label>

                        <div class="relative">
                            <input
                                class="w-full bg-fm-surface-low border-0 rounded-xl px-4 py-3 text-sm font-semibold text-fm-on-surface focus:ring-2 focus:ring-fm-primary/40 transition-all"
                                :value="selectedFile?.name"
                                @change="$wire.renameFile(selectedFile.id, $event.target.value)"
                                type="text"
                            />
                            <span
                                class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-fm-on-surface-variant text-sm">edit</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-fm-on-surface-variant">Metadata</label>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="fm-meta-card">
                                <span class="fm-meta-label">Size</span>

                                <p class="fm-meta-text" x-text="selectedFile?.size"></p>
                            </div>

                            <div class="fm-meta-card">
                                <span class="fm-meta-label">Type</span>

                                <div class="flex items-center gap-1.5">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-md bg-fm-secondary-container text-fm-on-secondary text-[10px] font-bold"
                                        x-text="selectedFile?.mime_type"></span>
                                </div>
                            </div>

                            <div class="fm-meta-card">
                                <span class="fm-meta-label">Created</span>
                                <p class="fm-meta-text" x-text="selectedFile?.created_at"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 h-20 border-t border-fm-surface-container flex items-center justify-between bg-fm-surface">

                <button
                    type="button"
                    class="flex items-center gap-2 text-fm-error px-4 py-2 rounded-full hover:bg-fm-error-container/20 transition-all active:scale-95 font-semibold text-sm"
                    @click="$wire.mountAction('delete', { id: selectedFile.id})">
                    <span class="material-symbols-outlined text-sm">delete</span>

                    Delete Asset
                </button>

                <div class="fm-row">

                    <button
                        class="px-6 py-2.5 rounded-full border border-fm-surface-container hover:bg-fm-surface-low transition-all text-fm-on-surface font-semibold text-sm"
                        @click="closeModal()">
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="px-8 py-2.5 rounded-full bg-linear-to-br from-fm-primary to-fm-primary-container text-white font-bold text-sm shadow-[0_4px_12px_rgba(70,72,212,0.3)] hover:shadow-[0_6px_16px_rgba(70,72,212,0.4)] transition-all active:scale-95 flex items-center gap-2"
                        @click="$wire.downloadFile(selectedFile.id)">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Download
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
