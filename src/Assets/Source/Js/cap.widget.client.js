const CapWidgetClient = {
  addHandler(options) {
    const widget = document.querySelector(`#${options.widgetId}`);
    widget.addEventListener('solve', options.onSolve);
  },
}
