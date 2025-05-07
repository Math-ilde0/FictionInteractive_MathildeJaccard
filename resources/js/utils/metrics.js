// resources/js/utils/
export const setMetric = (name, value) => {
  localStorage.setItem(name, value);
  console.log(`Métrique ${name} définie à ${value} dans localStorage`);
};

export const getMetric = (name, defaultValue) => {
  const value = localStorage.getItem(name);
  return value !== null ? parseInt(value) : defaultValue;
};