import { Switch, Route } from "wouter";
import { queryClient } from "./lib/queryClient";
import { QueryClientProvider } from "@tanstack/react-query";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import { useEffect } from "react";
import { initializeTheme } from './lib/theme-util';
import NotFound from "@/pages/not-found";
import Home from "@/pages/Home";
import BlogPage from "@/pages/blog-page";
import BlogDetailPage from "@/pages/blog-detail-page";
import AjukanPage from "@/pages/ajukan-page";
import DashboardPage from "@/pages/dashboard-page";
import DashboardHomePage from "@/pages/dashboard-home-page";
import SettingsPage from "@/pages/settings-page";
import TransactionsPage from "@/pages/transactions-page";
import CardsPage from "@/pages/cards-page";
import CompareCardsPage from "@/pages/compare-cards-page";
import PromotionsPage from "@/pages/promotions-page";
import SubscriptionPage from "@/pages/subscription-page";

function Router() {
  return (
    <Switch>
      <Route path="/" component={Home} />
      <Route path="/blog" component={BlogPage} />
      <Route path="/blog-detail/:id" component={BlogDetailPage} />
      <Route path="/ajukan" component={AjukanPage} />
      <Route path="/dashboard" component={DashboardPage} />
      <Route path="/dashboard-home" component={DashboardHomePage} />
      <Route path="/settings" component={SettingsPage} />
      <Route path="/transactions" component={TransactionsPage} />
      <Route path="/cards" component={CardsPage} />
      <Route path="/compare-cards" component={CompareCardsPage} />
      <Route path="/promotions" component={PromotionsPage} />
      <Route path="/subscription" component={SubscriptionPage} />
      {/* Fallback to 404 */}
      <Route component={NotFound} />
    </Switch>
  );
}

function App() {
  // Inisialisasi tema saat aplikasi dimuat
  useEffect(() => {
    initializeTheme();
  }, []);

  return (
    <QueryClientProvider client={queryClient}>
      <TooltipProvider>
        <Toaster />
        <Router />
      </TooltipProvider>
    </QueryClientProvider>
  );
}

export default App;
