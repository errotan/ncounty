import React, { Component } from 'react';

class CityEditor extends Component {
    render() {
        return (
            <form>
            <div className="form-group row no-gutters">
                <div className="col-sm">
                    <input type="text" className="form-control" id="editCityName" defaultValue={this.props.city.name} />
                </div>
                <div className="col-sm">
                    <button className="btn btn-danger ml-1" onClick={this.props.handleCityDelete}>Töröl</button>
                    <button className="btn btn-primary ml-1" onClick={this.props.handleCityUpdate}>Módosít</button>
                    <button className="btn btn-secondary ml-1" onClick={this.props.handleCancel}>Mégse</button>
                </div>
            </div>
        </form>
        );
    }
}

export default CityEditor;
