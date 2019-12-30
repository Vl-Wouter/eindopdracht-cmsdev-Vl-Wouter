export default class FormSerializer {
  static toJSON = form => {
    const formData = new FormData(form);
    let json = {};
    for (let pair of formData.entries()) {
      json[pair[0]] = pair[1];
    }
    return json;
  };
}
