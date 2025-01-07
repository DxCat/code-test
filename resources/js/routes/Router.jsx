import { Route, Routes } from 'react-router-dom';
import IndexPage from "../pages/IndexPage.jsx";
import CardPage from "../pages/CardPage.jsx";
import SQLPage from "../pages/SQLPage.jsx";

// Define routes
const ROUTES = [
  {
    name: 'home',
    path: '/',
    component: IndexPage
  },
  {
    name: 'card',
    path: '/card',
    component: CardPage
  },
  {
    name: 'sql',
    path: '/sql',
    component: SQLPage
  },
];

/**
 * Get route by name and params
 */
export const route = (name, param = {}) => {
  const routeConfig = ROUTES.find((route) => route.name === name);

  if (!routeConfig) {
    throw new Error(`Route with name ${name} not found`);
  }

  let path = routeConfig.path;

  path = path.replace(/:([a-zA-Z]+)\?/g, (match, key) => {
    return param[key] !== undefined ? param[key] : '';
  });

  path = path.replace(/:/g, '');
  path = path.replace(/\/+/g, '/').replace(/\/$/, '');

  return path || '/';
};

const Router = () => {
  return (
    <Routes>
      {ROUTES.map((route) => {
        const Component = route.component;
        return (
          <Route
            key={route.name}
            path={route.path}
            element={<Component />}
          />
        );
      })}
    </Routes>
  );
};

export default Router;
