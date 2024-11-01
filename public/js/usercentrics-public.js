window['usercentrics'] = window['usercentrics'] || {};
var locale = (document.documentElement.lang).split('-')[0] || false;
if (locale) {
  if (window['usercentrics'].isInitialized) {
    usercentrics.updateLanguage(locale);
  } else {
    usercentrics.onViewInit = function() {
      usercentrics.updateLanguage(locale);
    };
  }
}
