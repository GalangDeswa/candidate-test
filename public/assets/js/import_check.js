window.importChecker = function ({
    checkUrl,
    commitUrl,
    csrfToken
}) {
    return {

        dragging: false,
        fileName: '',

        loading: false,

        analysis: null,
        sessionId: null,

        globalConflictResolution: 'skip',
        resolutions: {},

        async processFile(file) {

            if (!file) return;

            this.fileName = file.name;

            this.loading = true;

            this.analysis = null;

            let formData = new FormData();

            formData.append('file', file);

            formData.append('_token', csrfToken);

            try {

                const response = await fetch(checkUrl, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                this.analysis = result.analysis;

                this.resolutions = {};

                if (this.analysis?.conflicts?.length) {

                    this.analysis.conflicts.forEach(conflict => {

                        const key =
                            conflict.uid ??
                            (
                                conflict.incoming.layup_uid
                                + '-'
                                + conflict.layer_order
                            );

                        this.resolutions[key] = 'skip';
                    });
                }

                this.sessionId = result.session_id;

                console.log(result);

            } catch (e) {

                console.error(e);

                alert('Import check failed');

            } finally {

                this.loading = false;
            }
        },

        async commitImport() {

            const resolutions = {
                suppliers: {},
                layups: {},
                layers: {},
            };

            if (this.analysis?.suppliers?.length) {

                this.analysis.suppliers.forEach(item => {

                    if (item.type !== 'CONFLICT') {
                        return;
                    }

                    resolutions.suppliers[item.uid] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[item.uid]
                            : this.globalConflictResolution;
                });
            }

            if (this.analysis?.layups?.length) {

                this.analysis.layups.forEach(item => {

                    if (item.type !== 'NAME_DUPLICATE') {
                        return;
                    }

                    resolutions.layups[item.uid] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[item.uid]
                            : this.globalConflictResolution;
                });
            }

            if (this.analysis?.layers?.length) {

                this.analysis.layers.forEach(item => {

                    if (item.type !== 'CONFLICT') {
                        return;
                    }

                    const key =
                        item.incoming.layup_uid
                        + '-'
                        + item.layer_order;

                    resolutions.layers[key] =
                        this.globalConflictResolution === 'manual'
                            ? this.resolutions[key]
                            : this.globalConflictResolution;
                });
            }

            console.log(resolutions);

            try {

                const response = await fetch(commitUrl, {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },

                    body: JSON.stringify({
                        session_id: this.sessionId,
                        resolutions,
                    }),
                });

                const result = await response.json();

                console.log(result);

                // alert(result.message);

             window.importModal = false;
             window.location.reload();

            } catch (e) {

                console.error(e);

                alert('Commit failed');
            }
        },

        badgeClass(type) {

            return {
                'IDENTICAL': 'bg-success',
                'UPDATE': 'bg-warning text-dark',
                'INVALID': 'bg-danger',
                'NEW': 'bg-primary',
                'DUPLICATE_IN_IMPORT': 'bg-secondary',
                'CONFLICT': 'bg-danger',
                'NAME_DUPLICATE': 'bg-danger',
                'DUPLICATE_LAYER': 'bg-danger',
            }[type] || 'bg-dark';
        },
    };
};