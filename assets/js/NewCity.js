import React, { Component } from 'react';

class NewCity extends Component {
    render() {
        return (
            <div className="bg-light border rounded mt-1 pt-3 px-3">
                <form onSubmit={this.props.handleCreateCity}>
                    <div className="form-group row">
                        <label htmlFor="newCityName" className="col-sm-5 col-form-label">Új település:</label>
                        <div className="col-sm-7">
                            <input type="text" className="form-control" id="newCityName" />
                        </div>
                        <div className="text-right w-100 mr-3 mt-3">
                            <button type="submit" className="btn btn-primary">Felvesz</button>
                        </div>
                    </div>
                </form>
            </div>
        );
    }
}

export default NewCity;
