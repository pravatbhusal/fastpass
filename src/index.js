import React from 'react';
import {Platform, StatusBar} from 'react-native';
import {createStackNavigator} from 'react-navigation';
import Home from "./screens/home";
import Customer from "./screens/customer";

// create the stackNavigator that holds all the pages (Intents)
const Navigation = createStackNavigator({
  Home: {screen: Home},
  Customer: {screen: Customer}
},
{
  // create a padding to avoid overlapping the navbar of the device
  cardStyle: {
    paddingTop: Platform.OS === 'ios' ? 0 : StatusBar.currentHeight
  }
});

// export the Index class as a Component
export default class Index extends React.Component {
  render() {
    return (
      <Navigation />
    );
  }
}
