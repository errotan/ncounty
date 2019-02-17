import React, { Component } from 'react';

class CityLister extends Component {
    render() {
        return (
            <div className="bg-light border rounded ml-1 pt-2 px-3">
                <h5>Megye: <small className="text-muted">{this.props.countyName}</small></h5>
                <h5 className="mb-3">Települések:</h5>
                {this.props.cities.map(
                    city => <p className="text-muted" key={city.id}>{city.name}</p>
                )}
                {0 === this.props.cities.length && <p>Nincs rögzítve település!</p>}
            </div>
        );
    }
}

export default CityLister;
