class CapWidgetForm {
  #widget = null;
  #jForm = null;
  #solved = false;

  constructor(widgetId) {
    this.#widget = document.getElementById(widgetId);
    this.#jForm = $(`#${widgetId}`).closest('form');

    if (0 !== this.#jForm.length) {
      this.#boundHandlers();
      this.#initEventListeners();
    }
  }

  #boundHandlers() {
    this.boundHandleReset = this.handleReset.bind(this);
    this.boundHandleSolve = this.handleSolve.bind(this);
    this.boundHandleBeforeSubmit = this.handleBeforeSubmit.bind(this);
  }

  #initEventListeners() {
    this.#widget.addEventListener('reset', this.boundHandleReset);
    this.#widget.addEventListener('solve', this.boundHandleSolve);
    this.#jForm.on('beforeSubmit', this.boundHandleBeforeSubmit);
  }

  handleReset() {
    this.#solved = false;
  }

  handleSolve(event) {
    if (null !== event.detail.token) {
      this.#solved = true;
    }
  }

  handleBeforeSubmit() {
    return this.#solved;
  }

  static create(widgetId) {
    return new CapWidgetForm(widgetId);
  }
}