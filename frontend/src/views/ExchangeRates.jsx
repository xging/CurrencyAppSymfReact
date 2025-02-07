import React, { useState, useMemo } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import CurrencySelector from "../components/exchangeRate/CurrencySelector";
import CurrencyTable from "../components/exchangeRate/CurrencyTable";
import Pagination from "../components/exchangeRate/Pagination";
import PageTitle from "../components/exchangeRate/PageTitle";
import PageFooter from "../components/exchangeRate/PageFooter";

const ExchangeRates = ({ jsonDataCurrencies, jsonDataInfo }) => {
    const [currency, setCurrency] = useState("EUR-GBP");
    const [currentPage, setCurrentPage] = useState(1);
    const [sortOrder, setSortOrder] = useState("ASC");
    const rowsPerPage = 5;

    // Get available currency pairs
    const availableCurrencies = useMemo(
        () => jsonDataCurrencies.map(item => item.currencyPair),
        [jsonDataCurrencies]
    );

    // Get historical exchange rate data and sort it
    const data = useMemo(() => {
        const selectedPair = jsonDataCurrencies.find(item => item.currencyPair === currency);
        if (!selectedPair) return [];

        return [...selectedPair.history].sort((a, b) =>
            sortOrder === "ASC"
                ? new Date(a.update_date) - new Date(b.update_date)
                : new Date(b.update_date) - new Date(a.update_date)
        );
    }, [currency, jsonDataCurrencies, sortOrder]);

    // Get the last update date
    const lastUpdateDate = useMemo(() => jsonDataInfo.length > 0 ? jsonDataInfo[0].value : "", [jsonDataInfo]);

    // Calculate total pages
    const totalPages = useMemo(() => Math.ceil(data.length / rowsPerPage), [data.length]);

    // Get paginated data for the current page
    const paginatedData = useMemo(() => {
        const start = (currentPage - 1) * rowsPerPage;
        return data.slice(start, start + rowsPerPage);
    }, [data, currentPage]);

    // Calculate min, max, and average values
    const maths = useMemo(() => {
        const lastRates = data.map(item => item.last_rate);
        if (lastRates.length === 0) return { minimum: null, maximum: null, average: null };

        return {
            minimum: parseFloat(Math.min(...lastRates).toPrecision(5)),
            maximum: parseFloat(Math.max(...lastRates).toPrecision(5)),
            average: parseFloat((lastRates.reduce((sum, rate) => sum + rate, 0) / lastRates.length).toPrecision(5))
        };
    }, [data]);

    return (
        <div className="container mt-5" style={{ maxWidth: "50%" }}>
            <CurrencySelector 
                currency={currency} 
                onCurrencyChange={newCurrency => {
                    setCurrency(newCurrency);
                    setCurrentPage(1); // Reset page on currency change
                }} 
                availableCurrencies={availableCurrencies} 
            />
            <PageTitle currency={currency} lastUpdateDate={lastUpdateDate} />
            <Pagination currentPage={currentPage} totalPages={totalPages} onPageChange={setCurrentPage} />
            <CurrencyTable currency={currency} data={paginatedData} sortOrder={sortOrder} setSortOrder={setSortOrder} />
            <Pagination currentPage={currentPage} totalPages={totalPages} onPageChange={setCurrentPage} />
            <PageFooter currency={currency} maths={maths} />
        </div>
    );
};

export default ExchangeRates;
