class CapWidgetClient {
  #widget = null;
  #form = null;
  #solved = false;

  constructor(widgetId) {
    this.#widget = document.getElementById(widgetId);
    this.#form = this.#widget.closest('form');

    if (null !== this.#form) {
      this.#boundHandlers();
      this.#initEventListeners();
    }
  }

  #boundHandlers() {
    this.boundHandleReset = this.handleReset.bind(this);
    this.boundHandleSolve = this.handleSolve.bind(this);
    this.boundHandleSubmit = this.handleSubmit.bind(this);
  }

  #initEventListeners() {
    this.#widget.addEventListener('reset', this.boundHandleReset);
    this.#widget.addEventListener('solve', this.boundHandleSolve);
    this.#form.addEventListener('submit', this.boundHandleSubmit);
  }

  handleReset() {
    this.#solved = false;
  }

  handleSolve(event) {
    if (null !== event.detail.token) {
      this.#solved = true;
    }
  }

  handleSubmit(event) {
    if (!this.#solved) {
      event.preventDefault();
    }
  }

  static create(widgetId) {
    return new CapWidgetClient(widgetId);
  }

  static addHandler(options) {
    const widget = document.getElementById(options.widgetId);
    widget.addEventListener('solve', options.onSolve);
  }
};
