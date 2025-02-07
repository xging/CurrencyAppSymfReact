const PageFooter = ({ currency, maths}) => {

    currency = currency.substring(currency.indexOf("-") + 1)

    return (
        <div className="mt-3">
            <p className="text-center">Minimum: {maths.minimum} {currency}, Maximum: {maths.maximum} {currency}</p>
            <p className="text-center">Average: {maths.average} {currency}</p>
        </div>

    );
};
export default PageFooter;

