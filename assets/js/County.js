import React, { Component } from 'react';

class County extends Component {
    render() {
        return (
            <div className="bg-light border rounded pt-3 px-3">
                <form>
                    <div className="form-group row">
                        <label htmlFor="countySelect" className="col-sm-3 col-form-label">Megye:</label>
                        <div className="col-sm-9">
                            <select className="form-control" id="countySelect" onChange={this.props.handleCountyChange}>
                                <option value="0">Válasszon!</option>
                                {this.props.counties.map(
                                    county => <option key={county.id} value={county.id}>{county.name}</option>
                                )}
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        );
    }
}

export default County;
