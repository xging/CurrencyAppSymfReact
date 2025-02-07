import React, { useState, useEffect } from 'react';
import ExchangeRates from '../../views/ExchangeRates';
import "bootstrap/dist/css/bootstrap.min.css";
import PageSpinner from '../pagedetails/PageSpinner';

const App = () => {
    const [jsonDataCurrencies, setJsonDataCurrencies] = useState([]);
    const [jsonDataInfo, setJsonDataInfo] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch('http://localhost:8080/get-currency-hist-all');
                const data = await response.json();

                if (data?.data?.currencies && typeof data.data.currencies === 'object') {
                    setJsonDataCurrencies(
                        Object.entries(data.data.currencies).map(([pair, rates]) => ({
                            currencyPair: pair,
                            history: rates
                        }))
                    );

                    setJsonDataInfo(
                        Object.entries(data.data.info).map(([param, value]) => ({
                            param,
                            value
                        }))
                    );
                } else {
                    throw new Error('Invalid data format');
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                setJsonDataCurrencies([]); // Ensure empty state on failure
            }
        };

        fetchData();
    }, []);

    if (!jsonDataCurrencies.length) {
        return (
            <PageSpinner />
        );
    }

    return (
        <div>
            <ExchangeRates jsonDataCurrencies={jsonDataCurrencies} jsonDataInfo={jsonDataInfo} />
        </div>
    );
};

export default App;
