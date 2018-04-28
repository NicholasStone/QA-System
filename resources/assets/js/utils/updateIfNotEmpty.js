import _ from 'lodash'

export default function (state, value, attribute) {
  if (!_.isEmpty(value)) {
    state[attribute] = value
  }
}
