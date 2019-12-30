export default class Validator {
  static validate(values) {
    for (let [key, value] of Object.entries(values)) {
      if (!value) {
        return {
          isValid: false,
          errorMsg: `${key} cannot be empty.`,
          field: key
        };
      }
    }
    return {
      isValid: true,
      errorMsg: null
    };
  }

  static validateTaskDetail(task) {
    let errors = [];
    const begin = new Date(task.begin_time);
    const end = new Date(task.end_time);

    for (let [key, value] of Object.entries(task)) {
      if (!value) {
        errors.push({
          level: "error",
          code: null,
          message: `${key} kan niet leeg zijn`
        });
      }
    }

    if (begin.getTime() > end.getTime())
      errors.push({
        level: "error",
        code: null,
        message: "Einduur moet later zijn dan beginuur"
      });

    if (errors.length > 0)
      return {
        isValid: false,
        errors: errors
      };

    return {
      isValid: true,
      errors: null
    };
  }
}
