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
  }

  handleSolve(event) {
    if (null !== event.detail.token) {
      this.#solved = true;
    }
  }

  handleAfterValidate() {
    let hint = this.#widget.nextElementSibling;
    
    if (this.#solved) {
      this.#widget.classList.remove('is-invalid');
      hint.textContent = '';
    } else {
      this.#widget.classList.add('is-invalid');
      hint.textContent = this.#widget.dataset.capI18nHintMessage;
    }
  }

  handleBeforeSubmit() {
    return this.#solved;
  }

  static create(widgetId) {
    return new CapWidgetForm(widgetId);
  }
}