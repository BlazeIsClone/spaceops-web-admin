/**
 * Textarea JS Class.
 *
 * Handles form textarea behaviour based on user interactions.
 */
class AppTextarea {
    constructor() {
        this.boot();
    }

    /**
     * Boot manager.
     */
    boot() {
        this.init();
    }

    /**
     * Listen and handle behaviour.
     */
    init() {
        this.maxlength();
    }

    /**
     * show visual feedback to the user about the maximum length.
     */
    maxlength() {
        $.when($.ready).then(function () {
            $('textarea.show-maxlength[maxlength]').maxlength({
                warningClass: "mt-1 badge badge-light-primary",
                limitReachedClass: "mt-1 badge badge-light-danger"
            });
        });
    }
}

// Initialize
const textarea = new AppTextarea();
