/**
 * @file metrics.js
 * @description
 * Utilitaires Vue pour gérer les métriques du joueur (charge mentale, sommeil, notes)
 * via le `localStorage`. Utilisé dans les composants de jeu pour lire, écrire et réinitialiser
 * les valeurs des indicateurs.
 *
 * Fonctionnalités :
 * - Sauvegarde et lecture de chaque métrique individuellement
 * - Réinitialisation des trois métriques en un appel
 * - Sécurisation des valeurs dans la plage 0–10
 *
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */

/**
 * Définit une métrique dans le localStorage, en la bornant entre 0 et 10.
 * @param {string} name - Nom de la métrique (ex: 'stress_level')
 * @param {number} value - Valeur souhaitée
 * @returns {number} - Valeur sauvegardée, corrigée si nécessaire
 */
export const setMetric = (name, value) => {
  const numValue = parseInt(value);
  const safeValue = Math.max(0, Math.min(10, numValue));
  localStorage.setItem(name, safeValue);
  return safeValue;
};

/**
 * Récupère une métrique depuis le localStorage, ou retourne une valeur par défaut.
 * @param {string} name - Nom de la métrique à lire
 * @param {number} [defaultValue=5] - Valeur par défaut si absente ou invalide
 * @returns {number} - Valeur entière de la métrique
 */
export const getMetric = (name, defaultValue = 5) => {
  const value = localStorage.getItem(name);
  if (value === null) return defaultValue;

  const numValue = parseInt(value);
  return isNaN(numValue) ? defaultValue : numValue;
};

/**
 * Réinitialise toutes les métriques aux valeurs de départ (stress: 3, sommeil: 7, notes: 6).
 */
export const resetMetrics = () => {
  setMetric('stress_level', 3);
  setMetric('sleep_level', 7);
  setMetric('grades_level', 6);
};

/**
 * Récupère toutes les métriques courantes sous forme d’objet.
 * @returns {{stress_level: number, sleep_level: number, grades_level: number}}
 */
export const getAllMetrics = () => {
  return {
    stress_level: getMetric('stress_level', 3),
    sleep_level: getMetric('sleep_level', 7),
    grades_level: getMetric('grades_level', 6)
  };
};
