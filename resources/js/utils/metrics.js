// resources/js/utils/
export const setMetric = (name, value) => {
  localStorage.setItem(name, value);
};

export const getMetric = (name, defaultValue) => {
  const value = localStorage.getItem(name);
  return value !== null ? parseInt(value) : defaultValue;
};