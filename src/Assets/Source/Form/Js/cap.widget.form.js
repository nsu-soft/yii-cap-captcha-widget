class CapWidgetForm {
  #widget = null;
  #jForm = null;
  #solved = false;

  constructor(widgetId) {
    this.#widget = document.getElementById(widgetId);
    this.#jForm = $(`#${widgetId}`).closest('form');

    if (0 !== this.#jForm.length) {
      this.#bindHandlers();
      this.#initEventListeners();
    }
  }

  #bindHandlers() {
    this.boundHandleReset = this.handleReset.bind(this);
    this.boundHandleSolve = this.handleSolve.bind(this);
    this.boundHandleAfterValidate = this.handleAfterValidate.bind(this);
    this.boundHandleBeforeSubmit = this.handleBeforeSubmit.bind(this);
  }

  #initEventListeners() {
    this.#widget.addEventListener('reset', this.boundHandleReset);
    this.#widget.addEventListener('solve', this.boundHandleSolve);
    this.#jForm.on('afterValidate', this.boundHandleAfterValidate);
    this.#jForm.on('beforeSubmit', this.boundHandleBeforeSubmit);
  }

  handleReset() {
    this.#solved = false;
    this.#showHint();
  }

  handleSolve(event) {
    if (null !== event.detail.token) {
      this.#solved = true;
      this.#hideHint();
    }
  }

  handleAfterValidate() {
    if (this.#solved) {
      this.#hideHint();
    } else {
      this.#showHint();
    }
  }

  handleBeforeSubmit() {
    return this.#solved;
  }

  #showHint() {
    this.#widget.classList.add('is-invalid');
    this.#widget.nextElementSibling.textContent = this.#widget.dataset.capI18nHintMessage;
  }

  #hideHint() {
    this.#widget.classList.remove('is-invalid');
    this.#widget.nextElementSibling.textContent = '';
  }

  static create(widgetId) {
    return new CapWidgetForm(widgetId);
  }
}