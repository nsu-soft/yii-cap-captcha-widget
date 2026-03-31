class CapWidgetSolve {
  static addHandler(options) {
    const widget = document.getElementById(options.widgetId);
    widget.addEventListener('solve', options.onSolve);
  }
};
