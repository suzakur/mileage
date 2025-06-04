// resources/js/app.tsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './react/src/App';
import { Switch, Route } from "wouter";
import { QueryClientProvider } from "@tanstack/react-query";
import * as Tooltip from '@radix-ui/react-tooltip';
import { SomeIcon } from 'lucide-react';
import { AlertCircle } from 'lucide-react';

ReactDOM.createRoot(document.getElementById('app')!).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);
