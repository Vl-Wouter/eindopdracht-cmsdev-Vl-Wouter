import axios from "axios";

export default class Api {
  static url = "http://localhost:8000/api";

  fetchToken = async data => {
    return await axios.post(`${this.url}/login_check`, data);
  };

  static fetchTasks = async (id, token) => {
    const tasks = await axios.get(`${this.url}/tasks/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    return tasks;
  };

  static updateTask = async (id, data, token) => {
    const updatedTask = await axios.put(`${this.url}/tasks/${id}`, data, {
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`
      }
    });
    return updatedTask;
  };
}
