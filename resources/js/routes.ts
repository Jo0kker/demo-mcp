// Fichier temporaire pour remplacer Wayfinder pendant le build de production
// En développement local, Wayfinder génère ce fichier automatiquement

export const home = () => '/';
export const dashboard = () => '/dashboard';
export const login = () => '/login';
export const register = () => '/register';
export const logout = () => '/logout';

// Nested route modules
export * as appearance from './routes/appearance';
export * as profile from './routes/profile';
export * as userPassword from './routes/user-password';
export * as password from './routes/password';
export * as twoFactor from './routes/two-factor';
export * as verification from './routes/verification';
