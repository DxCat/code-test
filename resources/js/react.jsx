import React from "react";
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from "react-router-dom";
import Router from "./routes/Router";

if (document.getElementById('app')) {
  const container = document.getElementById('app');
  const root = createRoot(container);

  const App = () => {
    return (
      <Router></Router>
    );
  };

  const AppWrapper = () => {
    return (
      <BrowserRouter basename='/'>
        <App />
      </BrowserRouter>
    );
  };

  root.render(<AppWrapper />);
}
